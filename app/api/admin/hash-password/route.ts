import { NextRequest, NextResponse } from 'next/server';
import { hashPassword } from '@/lib/password';
import { backendClient } from '@/sanity/lib/backendClient';

export async function POST(request: NextRequest) {
  try {
    const { adminId, rawPassword } = await request.json();

    if (!adminId || !rawPassword) {
      return NextResponse.json(
        { error: 'Admin ID and password are required' },
        { status: 400 }
      );
    }

    // Validate password format
    if (rawPassword.length < 12) {
      return NextResponse.json(
        { error: 'Password must be at least 12 characters' },
        { status: 400 }
      );
    }

    // Hash the password
    const hashedPassword = await hashPassword(rawPassword);

    // Update admin user with hashed password
    const result = await backendClient
      .patch(adminId)
      .set({
        password: hashedPassword,
        lastPasswordChange: new Date().toISOString()
      })
      .commit();

    return NextResponse.json({
      success: true,
      message: 'Password has been hashed and saved successfully',
      adminId: result._id
    });

  } catch (error) {
    console.error('Error hashing password:', error);
    return NextResponse.json(
      { error: 'Failed to hash and save password' },
      { status: 500 }
    );
  }
}