import 'package:flutter/material.dart';
import '../models/user_model.dart';
import '../services/user_service.dart';

class AdminProfileScreen extends StatefulWidget {
  const AdminProfileScreen({Key? key}) : super(key: key);

  @override
  _AdminProfileScreenState createState() => _AdminProfileScreenState();
}

class _AdminProfileScreenState extends State<AdminProfileScreen> {
  final UserService _userService = UserService();
  final _formKey = GlobalKey<FormState>();
  bool _isEditing = false;

  // Controllers for form fields
  final _usernameController = TextEditingController();
  final _addressController = TextEditingController();
  final _mobileNoController = TextEditingController();
  final _aadharNoController = TextEditingController();
  final _panCardNoController = TextEditingController();
  final _voterIdNoController = TextEditingController();
  final _ageController = TextEditingController();
  String? _selectedGender;
  final _constituencyController = TextEditingController();

  @override
  void dispose() {
    _usernameController.dispose();
    _addressController.dispose();
    _mobileNoController.dispose();
    _aadharNoController.dispose();
    _panCardNoController.dispose();
    _voterIdNoController.dispose();
    _ageController.dispose();
    _constituencyController.dispose();
    super.dispose();
  }

  void _startEditing(UserModel user) {
    setState(() {
      _isEditing = true;
      _usernameController.text = user.username ?? '';
      _addressController.text = user.address ?? '';
      _mobileNoController.text = user.mobileNo ?? '';
      _aadharNoController.text = user.aadharNo ?? '';
      _panCardNoController.text = user.panCardNo ?? '';
      _voterIdNoController.text = user.voterIdNo ?? '';
      _ageController.text = user.age?.toString() ?? '';
      _selectedGender = user.gender;
      _constituencyController.text = user.constituency ?? '';
    });
  }

  Future<void> _saveProfile() async {
    if (_formKey.currentState?.validate() ?? false) {
      final success = await _userService.updateProfile(
        username: _usernameController.text,
        address: _addressController.text,
        mobileNo: _mobileNoController.text,
        aadharNo: _aadharNoController.text,
        panCardNo: _panCardNoController.text,
        voterIdNo: _voterIdNoController.text,
        age: int.tryParse(_ageController.text),
        gender: _selectedGender,
        constituency: _constituencyController.text,
      );

      if (success && mounted) {
        ScaffoldMessenger.of(context).showSnackBar(
          const SnackBar(content: Text('Profile updated successfully')),
        );
        setState(() => _isEditing = false);
      } else if (mounted) {
        ScaffoldMessenger.of(context).showSnackBar(
          const SnackBar(content: Text('Failed to update profile')),
        );
      }
    }
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        title: const Text('Admin Profile'),
        actions: [
          StreamBuilder<UserModel?>(
            stream: _userService.getCurrentUserProfile(),
            builder: (context, snapshot) {
              if (snapshot.hasData && snapshot.data != null) {
                return IconButton(
                  icon: Icon(_isEditing ? Icons.save : Icons.edit),
                  onPressed: () {
                    if (_isEditing) {
                      _saveProfile();
                    } else {
                      _startEditing(snapshot.data!);
                    }
                  },
                );
              }
              return const SizedBox.shrink();
            },
          ),
        ],
      ),
      body: StreamBuilder<UserModel?>(
        stream: _userService.getCurrentUserProfile(),
        builder: (context, snapshot) {
          if (snapshot.hasError) {
            return Center(child: Text('Error: ${snapshot.error}'));
          }

          if (snapshot.connectionState == ConnectionState.waiting) {
            return const Center(child: CircularProgressIndicator());
          }

          final user = snapshot.data;
          if (user == null) {
            return const Center(child: Text('No profile data found'));
          }

          return SingleChildScrollView(
            padding: const EdgeInsets.all(16.0),
            child: Form(
              key: _formKey,
              child: Column(
                crossAxisAlignment: CrossAxisAlignment.start,
                children: [
                  Center(
                    child: CircleAvatar(
                      radius: 50,
                      backgroundImage: user.profileDp != null
                          ? NetworkImage(user.profileDp!)
                          : null,
                      child: user.profileDp == null
                          ? const Icon(Icons.person, size: 50)
                          : null,
                    ),
                  ),
                  const SizedBox(height: 24),
                  TextFormField(
                    controller: _usernameController,
                    decoration: const InputDecoration(
                      labelText: 'Username',
                      border: OutlineInputBorder(),
                    ),
                    enabled: _isEditing,
                    validator: (value) =>
                        value?.isEmpty ?? true ? 'Please enter username' : null,
                  ),
                  const SizedBox(height: 16),
                  TextFormField(
                    controller: _addressController,
                    decoration: const InputDecoration(
                      labelText: 'Address',
                      border: OutlineInputBorder(),
                    ),
                    enabled: _isEditing,
                    maxLines: 3,
                    validator: (value) =>
                        value?.isEmpty ?? true ? 'Please enter address' : null,
                  ),
                  const SizedBox(height: 16),
                  TextFormField(
                    controller: _mobileNoController,
                    decoration: const InputDecoration(
                      labelText: 'Mobile Number',
                      border: OutlineInputBorder(),
                    ),
                    enabled: _isEditing,
                    keyboardType: TextInputType.phone,
                    validator: (value) => value?.isEmpty ?? true
                        ? 'Please enter mobile number'
                        : null,
                  ),
                  const SizedBox(height: 16),
                  TextFormField(
                    controller: _aadharNoController,
                    decoration: const InputDecoration(
                      labelText: 'Aadhar Number',
                      border: OutlineInputBorder(),
                    ),
                    enabled: _isEditing,
                    keyboardType: TextInputType.number,
                    validator: (value) => value?.isEmpty ?? true
                        ? 'Please enter Aadhar number'
                        : null,
                  ),
                  const SizedBox(height: 16),
                  TextFormField(
                    controller: _panCardNoController,
                    decoration: const InputDecoration(
                      labelText: 'PAN Card Number',
                      border: OutlineInputBorder(),
                    ),
                    enabled: _isEditing,
                    validator: (value) => value?.isEmpty ?? true
                        ? 'Please enter PAN card number'
                        : null,
                  ),
                  const SizedBox(height: 16),
                  TextFormField(
                    controller: _voterIdNoController,
                    decoration: const InputDecoration(
                      labelText: 'Voter ID Number',
                      border: OutlineInputBorder(),
                    ),
                    enabled: _isEditing,
                    validator: (value) => value?.isEmpty ?? true
                        ? 'Please enter Voter ID number'
                        : null,
                  ),
                  const SizedBox(height: 16),
                  TextFormField(
                    controller: _ageController,
                    decoration: const InputDecoration(
                      labelText: 'Age',
                      border: OutlineInputBorder(),
                    ),
                    enabled: _isEditing,
                    keyboardType: TextInputType.number,
                    validator: (value) =>
                        value?.isEmpty ?? true ? 'Please enter age' : null,
                  ),
                  const SizedBox(height: 16),
                  DropdownButtonFormField<String>(
                    value: _selectedGender,
                    decoration: const InputDecoration(
                      labelText: 'Gender',
                      border: OutlineInputBorder(),
                    ),
                    items: const [
                      DropdownMenuItem(value: 'Male', child: Text('Male')),
                      DropdownMenuItem(value: 'Female', child: Text('Female')),
                      DropdownMenuItem(value: 'Other', child: Text('Other')),
                    ],
                    onChanged: _isEditing
                        ? (value) => setState(() => _selectedGender = value)
                        : null,
                    validator: (value) =>
                        value == null ? 'Please select gender' : null,
                  ),
                  const SizedBox(height: 16),
                  TextFormField(
                    controller: _constituencyController,
                    decoration: const InputDecoration(
                      labelText: 'Constituency',
                      border: OutlineInputBorder(),
                    ),
                    enabled: _isEditing,
                    validator: (value) => value?.isEmpty ?? true
                        ? 'Please enter constituency'
                        : null,
                  ),
                ],
              ),
            ),
          );
        },
      ),
    );
  }
}
