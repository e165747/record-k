import axios from "axios"
import { Ref, ref } from "vue"
import { useRouter } from 'vue-router'

export const useSignup = () => {
  const form = ref(null)
  const formValues = ref({
    username: "",
    password: "",
    passwordConfirmation: "",
  })
  const error: Ref<boolean> = ref(false)
  const errorMessage: Ref<string> = ref("")
  // バリデーションの結果が通ったか判定
  const isValid = ref(false)
  interface ValidationRules {
    email: (v: string) => boolean | string
    length: (len: number) => (v: string) => boolean | string
    // password: (v: string) => boolean | string
    passwordConfirmation: (v: string) => boolean | string
    required: (v: string) => boolean | string
  }
  const rules: Ref<ValidationRules> = ref({
    email: v => !!(v || '').match(/@/) || 'Please enter a valid email',
    length: len => v => (v || '').length >= len || `Invalid character length, required ${len}`,
    // パスワードルールは適当なのでとりあえずコメントアウト
    // password: v => !!(v || '').match(/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*(_|[^\w])).+$/) ||
    //   'Password must contain an upper case letter, a numeric character, and a special character',
    // パスワード確認（パスワードと同じ値か確認する）
    passwordConfirmation: (v: string) => v === formValues.value.password || 'Password confirmation does not match',
    required: v => !!v || 'This field is required',
  })
  const router = useRouter()
  const signup = async () => {
    try {
      // ここにログイン処理を記述
      await axios.post("/login", {
        email: formValues.value.username,
        password: formValues.value.password,
      })
      // ログイン成功後にHome画面に遷移
      router.push('/')
    } catch (e: any) {
      error.value = true
      errorMessage.value = e.response.data.error
    }
  }

  const clear = () => {
    formValues.value = {
      username: "",
      password: "",
      passwordConfirmation: "",
    }
  }

  const back = () => {
    router.back()
  }

  return {
    form,
    formValues,
    error,
    errorMessage,
    signup,
    isValid,
    rules,
    clear,
    back,
  }
}
