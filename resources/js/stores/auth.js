export default defineStore('auth', () => {
    const user = ref(undefined)
    const dates = ref([]);
    const users = ref([]);
    const isAdmin = computed(() => user.value?.admin)
    const id = computed(() => user.value?.id)
    const defaultPlaces = parseInt(import.meta.env.VITE_TEACHER_PLACE_AVAILABLE) || 5
    return { user, isAdmin,id,dates,users,defaultPlaces }
  })