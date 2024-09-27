declare global {
    interface UserElement {
        id: number;
        name: string;
        email: string;
        admin: boolean;
        deleteUser: () => void;
        active: boolean;
        company: { name: string };
        config: { group: boolean; slots: number; display_teacher_name: boolean,duration:number };
    }

    interface DateElement {
        id: number;
        places: Place[];
        waiting: { id: number, name: string }[];
        date: string;
        date_for_humans: string;
        old: boolean;
        user: UserElement;
        has_free_seats: number;
        already_reserved: boolean;
        already_waiting: boolean;
        deleteReservation: (key: number) => void;
        switchReservation: () => void;
        deleteDate: () => void;
    }
}

export { UserElement, DateElement };
