import { ref } from 'vue';

export function useLayoutSwitch(initialValue = false) {
  const horizontal = ref(initialValue);

  const changeHorizontal = () => {
    horizontal.value = true;
  };

  const changeVertical = () => {
    horizontal.value = false;
  };

  return { horizontal, changeHorizontal, changeVertical };
}
