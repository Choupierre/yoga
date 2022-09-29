export default defineStore('auth', () => {
  const user = ref(undefined)
  const dates = ref([]);
  const users = ref([]);
  const isAdmin = computed(() => user.value?.admin)
  const id = computed(() => user.value?.id)
  const appName = import.meta.env.VITE_APP_NAME
  const defaultPlaces = appName ==="Insa" ? 8 : 5
 
  const displayTeacherName = appName ==="Insa" ? true : false
  return { user, isAdmin, id, dates, users, defaultPlaces, appName, displayTeacherName }
})