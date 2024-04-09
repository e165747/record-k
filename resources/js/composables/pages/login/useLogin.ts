import { Ref, ref } from "vue";
export const useLogin = () => {
  const username: Ref<string> = ref("");
  const password: Ref<string> = ref("");
  const login = async () => {
    try {
      // ここにログイン処理を記述
      // await auth.signInWithEmailAndPassword(email, password)
    } catch (error: any) {
      throw new Error(error.message);
    }
  };

  return {
    username,
    password,
    login,
  };
};
