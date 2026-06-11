import {
  signInWithPopup
} from "firebase/auth";

import {
  auth,
  googleProvider,
  facebookProvider
} from "../firebase";

export async function googleLogin() {
  const result =
    await signInWithPopup(
      auth,
      googleProvider
    );

  return result.user;
}

export async function facebookLogin() {
  const result =
    await signInWithPopup(
      auth,
      facebookProvider
    );

  return result.user;
}