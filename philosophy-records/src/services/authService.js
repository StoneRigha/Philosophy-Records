import {
  signInWithPopup
} from "firebase/auth";

import {
  auth,
  googleProvider,
  facebookProvider
} from "../firebase";
import { signInWithFirebaseToken } from "./backendAuthService";

export async function googleLogin() {
  const result = await signInWithPopup(auth, googleProvider);
  return signInWithFirebaseToken(result.user);
}

export async function facebookLogin() {
  const result = await signInWithPopup(auth, facebookProvider);
  return signInWithFirebaseToken(result.user);
}
