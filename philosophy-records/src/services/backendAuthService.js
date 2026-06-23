const API_BASE = import.meta.env.VITE_API_BASE_URL || 'http://localhost:8000/api/v1';

export async function authenticateWithFirebase(idToken) {
  const response = await fetch(`${API_BASE}/auth/firebase`, {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
    },
    body: JSON.stringify({ id_token: idToken }),
  });

  if (!response.ok) {
    const error = await response.json().catch(() => null);
    throw new Error(error?.message || 'Failed to authenticate with backend');
  }

  return response.json();
}

export async function signInWithFirebaseToken(user) {
  const idToken = await user.getIdToken();
  return authenticateWithFirebase(idToken);
}
