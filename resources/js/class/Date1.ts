export class Date1 {
    places: Place[] = [];
    waiting: { id: number, name: string }[] = [];

    constructor(public date: DateElement) {
        this.mutate();
    }

    public mutate() {
        this.places = [];
        this.waiting = [];      
        this.date.places.forEach((user, key) => {
            this.places[key] = new Place(this, user, key);
        });
        this.date.waiting.forEach((place, key) => {
            this.waiting[key] = place;
        });
    }

    async switchReservation() {
        const res = await axios.post("/api/dates/switch/" + this.date.id);
        this.date = res.data;
        this.mutate();
    }

    async addWaiting() {
        const res = await axios.post("/api/dates/waiting/" + this.date.id);
        this.date = res.data;
        this.mutate();
    }
}