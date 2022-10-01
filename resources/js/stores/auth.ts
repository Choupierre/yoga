import { DateElement, User } from "../types";
export default defineStore('auth', () => {
  const appName = import.meta.env.VITE_APP_NAME
  const auth = ref<User>()
  const dates = ref<DateElement[]>()
  const users = ref<User[]>()

  const init = () => {
    axios.get("/api/store").then((res) => {
      auth.value = res.data.auth;   
      dates.value = res.data.dates;
      dates.value?.forEach(date => {
        date.freeSeats = function () { return date.places.reduce((prev: number, current: null | object) => prev + (current == null ? 1 : 0), 0) };
        date.alreadyReserved = function () { return !!date.places.find((place: { id: number }) => place && place.id === auth.value?.id) };
        date.deleteReservation = function (key) { axios.put("/api/dates/" + this.id, { key }).then(() => { init() }); }
        date.switchReservation = function (key?) { axios.post("/api/dates/switch/" + this.id, { key }).then(() => { init() }); }
        date.deleteDate = function (): void { if (window.confirm("voulez vous supprimer cette date?")) { axios.delete("/api/dates/" + this.id).then(() => { init() }); } }
        date.hour = function (key) {
          let hours = +this.date.slice(-5, -3);
          let minutes = +this.date.slice(-2);
          const coef = minutes + 30 >= 60 ? 1 : 0;
          hours = hours + Math.floor((key + coef) / 2);
          minutes = (minutes + 30 * key) % 60;
          return hours + "h" + (minutes === 0 ? "00" : minutes);
        }
        date.canReserveSeat = function (place: User | null) {

          if (isAdmin.value) return false;
          if (place && place.id !== auth.value?.id) return false;
          return isInsa.value && !this.old;
        }
      })
      users.value = res.data.users;
      users.value?.forEach(user => {
        user.deleteUser = function () { if (window.confirm('voulez vous supprimer cet élève?')) { axios.delete("/api/users/" + this.id).then(() => { init() }); } }
      })
    });
  }

  const isAdmin = computed(() => auth.value?.admin)
  const isInsa = computed(() => appName === "Insa")
  const isYoga = computed(() => appName === "Yoga")
  const defaultPlaces = computed(() => isInsa ? 8 : 5)
  const displayTeacherName = computed(() => isInsa ? true : false)

  return { init, auth, isAdmin, dates, users, defaultPlaces, appName, displayTeacherName, isInsa, isYoga }
})