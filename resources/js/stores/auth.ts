export default defineStore('auth', () => {
  const user = ref(undefined as undefined|{id:number,admin:boolean})
  const dates = ref([]);
  const users = ref([]);
  const isAdmin = computed(() => user.value?.admin)
  const id = computed(() => user.value?.id)
  const appName = import.meta.env.VITE_APP_NAME
  const isInsa = appName ==="Insa"
  const isYoga = appName ==="Yoga"
  const defaultPlaces = isInsa ? 8 : 5
 
  const displayTeacherName = isInsa ? true : false
  return { user, isAdmin, id, dates, users, defaultPlaces, appName, displayTeacherName,isInsa,isYoga }
})