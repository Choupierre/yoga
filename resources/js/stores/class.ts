export class Date1 {
    places: Place[] = [];
    waiting: { id: number, name: string }[] = [];

    constructor(public date: DateElement) {
        this.mutate();
    }

    public mutate() {
        console.log('rrr')
        this.places = [];
        this.waiting = [];
        this.date.places.forEach((place, key) => {            
            this.places[key] = new Place(this, place, key);
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

export class Place {
    constructor(public date: Date1, public place: UserElement | null, public key: number) { }

    hour() {
        const store = piniaStore();
        const date = new Date(this.date.date.date).getTime();
        const dateSlot = new Date(date + 1000 * 60 * (store.auth?.config.duration ?? 30) * this.key);
        return ("0" + dateSlot.getHours()).slice(-2) + "h" + ("0" + dateSlot.getMinutes()).slice(-2);
    }

    async deleteReservation() {
        if (window.confirm("voulez vous supprimer cette réservation?")) {
            this.date.date = await axios.put("/api/dates/" + this.date.date.id, { key: this.key }).then((res) => res.data as DateElement);
            this.date.mutate();
        }
    }
    async switchReservation() {
        this.date.date = await axios.post("/api/dates/switch/" + this.date.date.id, { key: this.key }).then((res) => res.data as DateElement);
        this.date.mutate();
    }
}
