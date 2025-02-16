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
    // パスワード確認（パスワードと同じ値か確認する）
    passwordConfirmation: (v: string) => v === formValues.value.password || 'Password confirmation does not match',
    required: v => !!v || 'This field is required',
  })

  // 成功時のスナックバー表示
  const snackbar = ref({
    show: false,
    text: "",
  })

  const router = useRouter()
  const signup = async () => {
    try {
      await axios.post("/api/signup", {
        name: formValues.value.username,
        email: formValues.value.username,
        password: formValues.value.password,
        password_confirmation: formValues.value.passwordConfirmation,
      })
      // サインアップ成功後にログイン画面に遷移
      snackbar.value = {
        show: true,
        text: "Sign up successful. Redirecting to login screen.",
      }
      setTimeout(() => {
        back()
      }, 3000)
    } catch (e: any) {
      error.value = true
      errorMessage.value = e.response.data.error
      snackbar.value = {
        show: true,
        text: "Sign up failed. Please try again.",
      }
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
    snackbar,
    signup,
    isValid,
    rules,
    clear,
    back,
  }
}
