export default defineStore("store", () => {
    const appName = import.meta.env.VITE_APP_NAME;
    const auth = ref<User>();
    const dates = ref<DateElement[]>([]);
    const users = ref<User[]>([]);

    async function init() {
        return axios.get("/api/store").then((res: { data: { auth: User; dates: DateElement[]; users: User[] } }) => {
            auth.value = res.data.auth;
            //auth.value.admin = false;
            res.data.dates.forEach((date: DateElement) => {
                dateMutation(date);
                date.places.forEach((place, key) => {
                    date.places[key] = placeMutation(date, place, key);
                });
            });
            res.data.users.forEach((user: User) => {
                userMutation(user);
            });
            dates.value = res.data.dates;
            users.value = res.data.users;
        });
    }

    function dateMutation(date: DateElement) {       
        date.switchReservation = async function () {
            await axios.post("/api/dates/switch/" + date.id);
            init();
        };
        date.deleteDate = async function () {
            if (window.confirm("voulez vous supprimer cette date?")) {
                await axios.delete("/api/dates/" + this.id);
                init();
            }
        };
    }

    function userMutation(user: User) {
        user.deleteUser = async function () {
            if (window.confirm("voulez vous supprimer cet élève?")) {
                await axios.delete("/api/users/" + this.id);
                init();
            }
        };
    }

    function placeMutation(date: DateElement, place: Place | null, key: number): Place {
        return {
            ...place,
            hour: (function () {
                let hours = +date.date.slice(-5, -3);
                let minutes = +date.date.slice(-2);
                const coef = minutes >= 30 ? 1 : 0;
                hours = hours + Math.floor((key + coef) / 2);
                minutes = (minutes + 30 * key) % 60;
                return hours + "h" + (minutes < 10 ? "0" : "") + minutes;
            })(),
            deleteReservation: async function () {
                if (window.confirm("voulez vous supprimer cette réservation?")) {
                    await axios.put("/api/dates/" + date.id, { key });
                    init();
                }
            },
            switchReservation: async function () {
                await axios.post("/api/dates/switch/" + date.id, { key });
                init();
            },
            canReserveSeat: (function () {
                if (isAdmin.value) return false;
                if (place && place.id !== auth.value?.id) return false;
                return isInsa.value && !date.old;
            })(),
        };
    }

    const dateComing = computed(() => dates.value.filter((date) => !date.old));
    const dateOld = computed(() => dates.value.filter((date) => date.old).reverse());

    const isAdmin = computed(() => auth.value?.admin === true);
    const isInsa = computed(() => appName === "Insa");
    const isYoga = computed(() => appName === "Yoga");
    const defaultPlaces = computed((): number => (isInsa.value ? 8 : 5));

    return {
        init,
        auth,
        isAdmin,
        dates,
        users,
        defaultPlaces,
        appName,
        isInsa,
        isYoga,
        dateComing,
        dateOld,
    };
});
