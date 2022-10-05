export class Date1 {
    places: Place[] = [];

    constructor(public date: DateElement) {
        this.mutate();
    }

    public mutate() {
        this.date.places.forEach((place, key) => {
            this.places[key] = new Place(this, place, key);
        });
    }

    async switchReservation() {
        const res = await axios.post("/api/dates/switch/" + this.date.id);
        this.date = res.data;
        this.mutate();
    }
}

export class Place {
    constructor(public date: Date1, public place: UserElement | null, public key: number) {}

    hour() {
        const date = new Date(this.date.date.date).getTime();
        const dateSlot = new Date(date + 1000 * 60 * 30 * this.key);
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
