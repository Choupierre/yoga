export default defineStore('auth', () => {
    const user = ref(undefined)
    const dates = ref([]);
    const users = ref([]);
    const isAdmin = computed(() => user.value?.admin)
    const id = computed(() => user.value?.id)
    return { user, isAdmin,id,dates,users }
  })