import axios from "axios"
import { Ref, ref } from "vue"
import { useRouter } from 'vue-router'

export const useLogin = () => {
  const form = ref(null)
  const username: Ref<string> = ref("")
  const password: Ref<string> = ref("")
  const error: Ref<boolean> = ref(false)
  const errorMessage: Ref<string> = ref("")
  // バリデーションの結果が通ったか判定
  const isValid = ref(false)
  interface ValidationRules {
    email: (v: string) => boolean | string
    length: (len: number) => (v: string) => boolean | string
    // password: (v: string) => boolean | string
    required: (v: string) => boolean | string
  }
  const rules: Ref<ValidationRules> = ref({
    email: v => !!(v || '').match(/@/) || 'Please enter a valid email',
    length: len => v => (v || '').length >= len || `Invalid character length, required ${len}`,
    // パスワードルールは適当なのでとりあえずコメントアウト
    // password: v => !!(v || '').match(/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*(_|[^\w])).+$/) ||
    //   'Password must contain an upper case letter, a numeric character, and a special character',
    required: v => !!v || 'This field is required',
  })
  const router = useRouter()
  const login = async () => {
    try {
      // ここにログイン処理を記述
      await axios.post("/login", {
        email: username.value,
        password: password.value,
      })
      // ログイン成功後にHome画面に遷移
      router.push('/')
    } catch (e: any) {
      error.value = true
      errorMessage.value = e.response.data.error
    }
  }

  const mounted = async () => {
    try {
      const csrfResponse = await axios.get("/sanctum/csrf-cookie")
      //ここでログイン済みか判定し，Homeに飛ばす
      if (csrfResponse.status === 204) {
        const userResponse = await axios.get("/api/me")
        if (userResponse.data) {
          username.value = userResponse.data.name
          const currentRoute = router.currentRoute.value.path
          if (currentRoute === '/login') {
            router.push('/')
          }
        }
      }
    } catch (error: any) {
      throw new Error(error.message)
    }
  }

  const clear = () => {
    username.value = ""
    password.value = ""
  }

  return {
    form,
    username,
    password,
    error,
    errorMessage,
    login,
    isValid,
    rules,
    mounted,
    clear
  }
}
