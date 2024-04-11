import axios from "axios";
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

  const mounted = async () => {
    try {
      const csrfResponse = await axios.get("/sanctum/csrf-cookie");
      // ここにログイン済みユーザーの取得処理を記述
      // const user = await auth.currentUser
      // if (user) {
      //   router.push('/')
      // }
    } catch (error: any) {
      throw new Error(error.message);
    }
  }

  return {
    username,
    password,
    login,
    mounted
  };
};
