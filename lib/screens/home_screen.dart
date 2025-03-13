/**
 * Created by Mahmud Ahsan
 * https://github.com/mahmudahsan
 */
import 'package:flutter/material.dart';
import 'package:flutter_firebase_vote/services/services.dart';
import 'package:flutter_firebase_vote/state/vote.dart';
import 'package:provider/provider.dart';
import 'login_screen.dart';
import 'signup_screen.dart';
import 'package:firebase_auth/firebase_auth.dart';

class HomeScreen extends StatefulWidget {
  const HomeScreen({Key? key}) : super(key: key);

  @override
  _HomeScreenState createState() => _HomeScreenState();
}

class _HomeScreenState extends State<HomeScreen> {
  int _currentStep = 0;

  @override
  void initState() {
    super.initState();
    // Only load votes if user is authenticated
    if (FirebaseAuth.instance.currentUser != null) {
      Future.microtask(() {
        if (mounted) {
          Provider.of<VoteState>(context, listen: false).clearState();
          Provider.of<VoteState>(context, listen: false).loadVoteList(context);
        }
      });
    }
  }

  Step getStep({
    required String title,
    required Widget child,
    required bool isActive,
  }) {
    return Step(
      title: Text(title),
      content: child,
      isActive: isActive,
    );
  }

  void showSnackBar(BuildContext context, String message) {
    ScaffoldMessenger.of(context).showSnackBar(
      SnackBar(content: Text(message)),
    );
  }

  Future<void> markMyVote(VoteState voteState) async {
    if (await voteState.submitVote(context)) {
      if (mounted) {
        showSnackBar(context, 'Vote submitted successfully!');
      }
    } else {
      if (mounted) {
        showSnackBar(context, 'Failed to submit vote. Please try again.');
      }
    }
  }

  Widget _buildAuthScreen() {
    return Center(
      child: Column(
        mainAxisAlignment: MainAxisAlignment.center,
        children: [
          const Text(
            'Welcome to E-Votex',
            style: TextStyle(
              fontSize: 24,
              fontWeight: FontWeight.bold,
            ),
          ),
          const SizedBox(height: 30),
          ElevatedButton(
            onPressed: () {
              Navigator.push(
                context,
                MaterialPageRoute(builder: (context) => const LoginScreen()),
              );
            },
            child: const Text('Login'),
          ),
          const SizedBox(height: 20),
          ElevatedButton(
            onPressed: () {
              Navigator.push(
                context,
                MaterialPageRoute(builder: (context) => const SignupScreen()),
              );
            },
            child: const Text('Sign Up'),
          ),
        ],
      ),
    );
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        title: const Text('E-Votex'),
        centerTitle: true,
        actions: [
          if (FirebaseAuth.instance.currentUser != null)
            IconButton(
              icon: const Icon(Icons.logout),
              onPressed: () async {
                await AuthService().signOut();
                if (mounted) {
                  Navigator.of(context).pushReplacement(
                    MaterialPageRoute(builder: (context) => const HomeScreen()),
                  );
                }
              },
            ),
        ],
      ),
      body: FirebaseAuth.instance.currentUser == null
          ? _buildAuthScreen()
          : Consumer<VoteState>(
              builder: (context, voteState, child) {
                if (voteState.voteList == null) {
                  return const Center(
                    child: CircularProgressIndicator(),
                  );
                }

                return Stepper(
                  type: StepperType.horizontal,
                  currentStep: _currentStep,
                  steps: [
                    getStep(
                      title: 'Choose',
                      child: VoteListWidget(voteState: voteState),
                      isActive: true,
                    ),
                    getStep(
                      title: 'Vote',
                      child: VoteWidget(voteState: voteState),
                      isActive: _currentStep >= 1,
                    ),
                  ],
                  onStepCancel: () {
                    if (_currentStep <= 0) {
                      voteState.activeVote = null;
                    } else if (_currentStep <= 1) {
                      voteState.selectedOptionInActiveVote = null;
                    }

                    setState(() {
                      _currentStep = (_currentStep - 1).clamp(0, 1);
                    });
                  },
                  onStepContinue: () async {
                    if (_currentStep == 0) {
                      if (voteState.activeVote != null) {
                        setState(() {
                          _currentStep = 1;
                        });
                      } else {
                        showSnackBar(context, 'Please select a vote first!');
                      }
                    } else if (_currentStep == 1) {
                      if (voteState.selectedOptionInActiveVote != null) {
                        await markMyVote(voteState);
                        if (mounted) {
                          Navigator.pushReplacementNamed(context, '/result');
                        }
                      } else {
                        showSnackBar(context, 'Please mark your vote!');
                      }
                    }
                  },
                );
              },
            ),
    );
  }
}

class VoteListWidget extends StatelessWidget {
  final VoteState voteState;

  const VoteListWidget({
    Key? key,
    required this.voteState,
  }) : super(key: key);

  @override
  Widget build(BuildContext context) {
    return ListView.builder(
      shrinkWrap: true,
      itemCount: voteState.voteList?.length ?? 0,
      itemBuilder: (context, index) {
        final vote = voteState.voteList![index];
        return Card(
          margin: const EdgeInsets.symmetric(vertical: 8),
          child: ListTile(
            title: Text(vote.voteTitle),
            subtitle: Text('${vote.options.length} options available'),
            selected: vote.voteId == voteState.activeVote?.voteId,
            onTap: () => voteState.activeVote = vote,
          ),
        );
      },
    );
  }
}

class VoteWidget extends StatelessWidget {
  final VoteState voteState;

  const VoteWidget({
    Key? key,
    required this.voteState,
  }) : super(key: key);

  @override
  Widget build(BuildContext context) {
    if (voteState.activeVote == null) {
      return const Center(
        child: Text('Please select a vote first'),
      );
    }

    return Column(
      crossAxisAlignment: CrossAxisAlignment.start,
      children: [
        Text(
          voteState.activeVote!.voteTitle,
          style: Theme.of(context).textTheme.titleLarge,
        ),
        const SizedBox(height: 16),
        ...voteState.activeVote!.options.map((option) {
          final optionName = option.keys.first;
          final votes = option.values.first;
          return RadioListTile<String>(
            title: Text(optionName),
            subtitle: Text('Current votes: $votes'),
            value: optionName,
            groupValue: voteState.selectedOptionInActiveVote,
            onChanged: (value) => voteState.selectedOptionInActiveVote = value,
          );
        }).toList(),
      ],
    );
  }
}
