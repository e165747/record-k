import axios from "axios";
import { useRouter } from "vue-router";

export const useLogout = () => {
  const router = useRouter()
  const logout = async () => {
    try {
      // ここにログアウト処理を記述
      await axios.post("/logout");
      // ログアウト成功後にLogin画面に遷移
      console.log('ログアウトしました')
      router.push('/login')
    } catch (error: any) {
      throw new Error(error.message);
    }
  }
  return {
    logout
  }
}