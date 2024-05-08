import axios from "axios";
import { Ref, ref } from "vue";
import { useRouter } from 'vue-router'

export const useLogin = () => {
  const username: Ref<string> = ref("");
  const password: Ref<string> = ref("");
  const router = useRouter()
  const login = async () => {
    try {
      // ここにログイン処理を記述
      await axios.post("/login", {
        email: username.value,
        password: password.value,
      });
      // ログイン成功後にHome画面に遷移
      router.push('/')
    } catch (error: any) {
      throw new Error(error.message);
    }
  };

  const mounted = async () => {
    try {
      const csrfResponse = await axios.get("/sanctum/csrf-cookie");
      //ここでログイン済みか判定し，Homeに飛ばす
      if (csrfResponse.status === 204) {
        const userResponse = await axios.get("/api/me");
        if (userResponse.data) {
          router.push('/')
        }
      }
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
