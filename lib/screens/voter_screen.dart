import 'package:flutter/material.dart';
import '../services/vote_service.dart';
import '../models/vote.dart';
import '../services/auth_service.dart';
import 'voter_profile_screen.dart';

class VoterScreen extends StatefulWidget {
  const VoterScreen({Key? key}) : super(key: key);

  @override
  _VoterScreenState createState() => _VoterScreenState();
}

class _VoterScreenState extends State<VoterScreen> {
  final VoteService _voteService = VoteService();
  final AuthService _authService = AuthService();
  int _selectedIndex = 0;

  Widget _buildVoteList() {
    return StreamBuilder<List<Vote>>(
      stream: _voteService.getVotes(),
      builder: (context, snapshot) {
        if (snapshot.hasError) {
          return Center(child: Text('Error: ${snapshot.error}'));
        }

        if (snapshot.connectionState == ConnectionState.waiting) {
          return const Center(child: CircularProgressIndicator());
        }

        final votes = snapshot.data ?? [];
        if (votes.isEmpty) {
          return const Center(child: Text('No votes available'));
        }

        return ListView.builder(
          itemCount: votes.length,
          itemBuilder: (context, index) {
            final vote = votes[index];
            return Card(
              margin: const EdgeInsets.all(8.0),
              child: ListTile(
                title: Text(vote.voteTitle),
                subtitle: Text('${vote.options.length} options'),
                trailing: ElevatedButton(
                  onPressed: () async {
                    // Show dialog to select option
                    final selectedOption = await showDialog<String>(
                      context: context,
                      builder: (context) => AlertDialog(
                        title: Text(vote.voteTitle),
                        content: SingleChildScrollView(
                          child: Column(
                            mainAxisSize: MainAxisSize.min,
                            children: vote.options.map((option) {
                              return ListTile(
                                title: Text(option.keys.first),
                                onTap: () =>
                                    Navigator.pop(context, option.keys.first),
                              );
                            }).toList(),
                          ),
                        ),
                      ),
                    );

                    if (selectedOption != null) {
                      final success = await _voteService.submitVote(
                        vote.voteId,
                        selectedOption,
                        _authService.currentUser?.uid ?? '',
                      );
                      if (success && mounted) {
                        ScaffoldMessenger.of(context).showSnackBar(
                          const SnackBar(
                              content: Text('Vote submitted successfully')),
                        );
                      } else if (mounted) {
                        ScaffoldMessenger.of(context).showSnackBar(
                          const SnackBar(
                              content: Text('Failed to submit vote')),
                        );
                      }
                    }
                  },
                  child: const Text('Vote'),
                ),
              ),
            );
          },
        );
      },
    );
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        title: const Text('Available Votes'),
        actions: [
          IconButton(
            icon: const Icon(Icons.logout),
            onPressed: () async {
              await _authService.signOut();
              if (mounted) {
                Navigator.of(context).pushReplacementNamed('/login');
              }
            },
          ),
        ],
      ),
      body: _selectedIndex == 0 ? _buildVoteList() : const VoterProfileScreen(),
      bottomNavigationBar: BottomNavigationBar(
        currentIndex: _selectedIndex,
        onTap: (index) => setState(() => _selectedIndex = index),
        items: const [
          BottomNavigationBarItem(
            icon: Icon(Icons.how_to_vote),
            label: 'Votes',
          ),
          BottomNavigationBarItem(
            icon: Icon(Icons.person),
            label: 'Profile',
          ),
        ],
      ),
    );
  }
}
