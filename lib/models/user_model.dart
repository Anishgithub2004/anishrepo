class UserModel {
  final String uid;
  final String email;
  final String role; // e.g., "admin" or "voter"
  final String? username;
  final String? address;
  final String? mobileNo;
  final String? aadharNo;
  final String? panCardNo;
  final String? voterIdNo;
  final int? age;
  final String? gender;
  final String? constituency;
  final String? profileDp;

  UserModel({
    required this.uid,
    required this.email,
    required this.role,
    this.username,
    this.address,
    this.mobileNo,
    this.aadharNo,
    this.panCardNo,
    this.voterIdNo,
    this.age,
    this.gender,
    this.constituency,
    this.profileDp,
  });

  // Convert a UserModel instance into a Map
  Map<String, dynamic> toMap() {
    return {
      'uid': uid,
      'email': email,
      'role': role,
      'username': username,
      'address': address,
      'mobileNo': mobileNo,
      'aadharNo': aadharNo,
      'panCardNo': panCardNo,
      'voterIdNo': voterIdNo,
      'age': age,
      'gender': gender,
      'constituency': constituency,
      'profileDp': profileDp,
    };
  }

  // Convert a Map into a UserModel instance
  factory UserModel.fromMap(Map<String, dynamic> map) {
    return UserModel(
      uid: map['uid'] ?? '',
      email: map['email'] ?? '',
      role: map['role'] ?? 'voter', // Default role is 'voter'
      username: map['username'],
      address: map['address'],
      mobileNo: map['mobileNo'],
      aadharNo: map['aadharNo'],
      panCardNo: map['panCardNo'],
      voterIdNo: map['voterIdNo'],
      age: map['age']?.toInt(),
      gender: map['gender'],
      constituency: map['constituency'],
      profileDp: map['profileDp'],
    );
  }

  // Create a copy of UserModel with some fields updated
  UserModel copyWith({
    String? username,
    String? address,
    String? mobileNo,
    String? aadharNo,
    String? panCardNo,
    String? voterIdNo,
    int? age,
    String? gender,
    String? constituency,
    String? profileDp,
  }) {
    return UserModel(
      uid: this.uid,
      email: this.email,
      role: this.role,
      username: username ?? this.username,
      address: address ?? this.address,
      mobileNo: mobileNo ?? this.mobileNo,
      aadharNo: aadharNo ?? this.aadharNo,
      panCardNo: panCardNo ?? this.panCardNo,
      voterIdNo: voterIdNo ?? this.voterIdNo,
      age: age ?? this.age,
      gender: gender ?? this.gender,
      constituency: constituency ?? this.constituency,
      profileDp: profileDp ?? this.profileDp,
    );
  }
}
