export const useAuthStore = defineStore("auth", () => {

    const auth = ref<UserElement>();

    const company = ref<Company>();

    const dates = ref<DateElement[]>([]);

    const users = ref<UserElement[]>([]);

    async function init() {
        return axios.get<{ auth: UserElement; company: Company; dates: DateElement[]; users: UserElement[] }>("/api/store").then((res) => {
            auth.value = res.data.auth;
            company.value = res.data.company;
            dates.value = res.data.dates
            users.value = res.data.users;
        });
    }

    const dateComing = computed(() => dates.value.filter((date) => !date.old));
    const dateOld = computed(() => dates.value.filter((date) => date.old).reverse());

    return {
        init,
        auth,
        company,
        dates,
        users,
        dateComing,
        dateOld,
    };
});