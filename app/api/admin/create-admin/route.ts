import { NextRequest, NextResponse } from 'next/server';
import { backendClient } from '@/sanity/lib/backendClient';

export async function POST(request: NextRequest) {
  try {
    const body = await request.json();
    const { name, email, role = 'admin', isActive = true } = body;

    if (!name || !email) {
      return NextResponse.json(
        { error: 'Name and email are required' },
        { status: 400 }
      );
    }

    // Check if admin already exists
    const existingAdmin = await backendClient.fetch(
      `*[_type == "admin" && email == $email][0]`,
      { email }
    );

    if (existingAdmin) {
      return NextResponse.json(
        { error: 'Admin with this email already exists', admin: existingAdmin },
        { status: 409 }
      );
    }

    // Create new admin
    const adminData = {
      _type: 'admin',
      name,
      email,
      role,
      isActive
    };

    const result = await backendClient.create(adminData);

    return NextResponse.json({
      success: true,
      admin: result,
      message: 'Admin created successfully'
    });

  } catch (error) {
    console.error('Error creating admin:', error);
    return NextResponse.json(
      { error: 'Failed to create admin' },
      { status: 500 }
    );
  }
}