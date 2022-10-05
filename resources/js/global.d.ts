declare global {
    interface UserElement {
        id: number;
        name: string;
        email: string;
        admin: boolean;
        deleteUser: () => void;
        created_at: string;
        updated_at: string;
        company: { name: string };
        config: { group: boolean; slots: number; display_teacher_name: boolean };
    }

    interface DateElement {
        id: number;
        places: Place[];
        date: string;
        date_for_humans: string;
        old: boolean;
        user: UserElement;
        has_free_seats: number;
        already_reserved: boolean;
        deleteReservation: (key: number) => void;
        switchReservation: () => void;
        deleteDate: () => void;
    }
}

export { UserElement, DateElement };
