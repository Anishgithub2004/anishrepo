import 'package:cloud_firestore/cloud_firestore.dart';
import 'package:firebase_auth/firebase_auth.dart';
import '../models/user_model.dart';

class UserService {
  final FirebaseFirestore _firestore = FirebaseFirestore.instance;
  final FirebaseAuth _auth = FirebaseAuth.instance;

  // Get current user profile
  Stream<UserModel?> getCurrentUserProfile() {
    final userId = _auth.currentUser?.uid;
    if (userId == null) return Stream.value(null);

    return _firestore
        .collection('users')
        .doc(userId)
        .snapshots()
        .map((doc) => doc.exists ? UserModel.fromMap(doc.data()!) : null);
  }

  // Update user profile
  Future<bool> updateProfile({
    String? username,
    String? profileDp,
    String? address,
    String? mobileNo,
    String? aadharNo,
    String? panCardNo,
    String? voterIdNo,
    int? age,
    String? gender,
    String? constituency,
  }) async {
    try {
      final userId = _auth.currentUser?.uid;
      if (userId == null) return false;

      final Map<String, dynamic> updateData = {};

      if (username != null) updateData['username'] = username;
      if (profileDp != null) updateData['profileDp'] = profileDp;
      if (address != null) updateData['address'] = address;
      if (mobileNo != null) updateData['mobileNo'] = mobileNo;
      if (aadharNo != null) updateData['aadharNo'] = aadharNo;
      if (panCardNo != null) updateData['panCardNo'] = panCardNo;
      if (voterIdNo != null) updateData['voterIdNo'] = voterIdNo;
      if (age != null) updateData['age'] = age;
      if (gender != null) updateData['gender'] = gender;
      if (constituency != null) updateData['constituency'] = constituency;

      await _firestore.collection('users').doc(userId).update(updateData);
      return true;
    } catch (e) {
      print('Error updating profile: $e');
      return false;
    }
  }
}
