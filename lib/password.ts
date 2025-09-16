import bcrypt from 'bcrypt';

// Salt rounds untuk bcrypt (12 adalah standar yang aman)
const SALT_ROUNDS = 12;

/**
 * Validasi password berdasarkan standar internasional
 * Persyaratan:
 * - Minimal 12 karakter
 * - Kombinasi huruf besar dan kecil
 * - Minimal 1 angka
 * - Minimal 1 karakter khusus
 */
export interface PasswordValidationResult {
  isValid: boolean;
  errors: string[];
}

export function validatePassword(password: string): PasswordValidationResult {
  const errors: string[] = [];

  // Minimal 12 karakter
  if (password.length < 12) {
    errors.push('Password harus minimal 12 karakter');
  }

  // Huruf besar
  if (!/[A-Z]/.test(password)) {
    errors.push('Password harus mengandung minimal 1 huruf besar');
  }

  // Huruf kecil
  if (!/[a-z]/.test(password)) {
    errors.push('Password harus mengandung minimal 1 huruf kecil');
  }

  // Angka
  if (!/\d/.test(password)) {
    errors.push('Password harus mengandung minimal 1 angka');
  }

  // Karakter khusus
  if (!/[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]/.test(password)) {
    errors.push('Password harus mengandung minimal 1 karakter khusus (!@#$%^&*()_+-=[]{}|;:,.<>?)');
  }

  // Tidak boleh mengandung spasi
  if (/\s/.test(password)) {
    errors.push('Password tidak boleh mengandung spasi');
  }

  return {
    isValid: errors.length === 0,
    errors
  };
}

/**
 * Hash password menggunakan bcrypt
 */
export async function hashPassword(password: string): Promise<string> {
  try {
    const hashedPassword = await bcrypt.hash(password, SALT_ROUNDS);
    return hashedPassword;
  } catch {
    throw new Error('Gagal melakukan hash password');
  }
}

/**
 * Verifikasi password dengan hash yang tersimpan
 */
export async function verifyPassword(password: string, hashedPassword: string): Promise<boolean> {
  try {
    const isValid = await bcrypt.compare(password, hashedPassword);
    return isValid;
  } catch {
    throw new Error('Gagal memverifikasi password');
  }
}

/**
 * Generate password yang memenuhi kriteria (untuk testing atau reset password)
 */
export function generateSecurePassword(length: number = 16): string {
  const uppercase = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
  const lowercase = 'abcdefghijklmnopqrstuvwxyz';
  const numbers = '0123456789';
  const symbols = '!@#$%^&*()_+-=[]{}|;:,.<>?';
  
  let password = '';
  
  // Pastikan minimal 1 karakter dari setiap kategori
  password += uppercase[Math.floor(Math.random() * uppercase.length)];
  password += lowercase[Math.floor(Math.random() * lowercase.length)];
  password += numbers[Math.floor(Math.random() * numbers.length)];
  password += symbols[Math.floor(Math.random() * symbols.length)];
  
  // Isi sisa karakter secara random
  const allChars = uppercase + lowercase + numbers + symbols;
  for (let i = password.length; i < length; i++) {
    password += allChars[Math.floor(Math.random() * allChars.length)];
  }
  
  // Shuffle password untuk menghindari pola yang dapat diprediksi
  return password.split('').sort(() => Math.random() - 0.5).join('');
}

/**
 * Cek kekuatan password (untuk UI feedback)
 */
export interface PasswordStrength {
  score: number; // 0-4 (0: sangat lemah, 4: sangat kuat)
  feedback: string;
  color: 'red' | 'orange' | 'yellow' | 'blue' | 'green';
}

export function checkPasswordStrength(password: string): PasswordStrength {
  let score = 0;
  
  if (password.length >= 12) score++;
  if (password.length >= 16) score++;
  if (/[A-Z]/.test(password) && /[a-z]/.test(password)) score++;
  if (/\d/.test(password)) score++;
  if (/[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]/.test(password)) score++;
  
  // Bonus untuk variasi karakter
  const uniqueChars = new Set(password).size;
  if (uniqueChars >= password.length * 0.7) score++;
  
  // Maksimal score 4
  score = Math.min(score, 4);
  
  const strengthMap: Record<number, { feedback: string; color: PasswordStrength['color'] }> = {
    0: { feedback: 'Sangat Lemah', color: 'red' },
    1: { feedback: 'Lemah', color: 'orange' },
    2: { feedback: 'Sedang', color: 'yellow' },
    3: { feedback: 'Kuat', color: 'blue' },
    4: { feedback: 'Sangat Kuat', color: 'green' }
  };
  
  return {
    score,
    ...strengthMap[score]
  };
}