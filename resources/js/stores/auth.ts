export const useAuthStore = defineStore("auth", () => {

    const auth = ref<UserElement>();

    const dates = ref<Date1[]>([]);

    const users = ref<UserElement[]>([]);

    async function init() {
        return axios.get("/api/store").then((res: { data: { auth: UserElement; dates: DateElement[]; users: UserElement[] } }) => {
            auth.value = res.data.auth;
            dates.value = res.data.dates.map((date) => new Date1(date));
            users.value = res.data.users;
        });
    }

    const dateComing = computed(() => dates.value.filter((date) => !date.date.old));
    const dateOld = computed(() => dates.value.filter((date) => date.date.old).reverse());

    return {
        init,
        auth,
        dates,
        users,
        dateComing,
        dateOld,
    };
});