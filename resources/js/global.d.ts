declare global {
    interface User {
        id: number;
        name: string;
        email: string;
        admin: boolean;
        deleteUser: () => void;
        created_at: string;
        updated_at: string;
    }

    interface DateElement {
        id: number;
        places: Place[];
        date: string;
        old: boolean;
        user: User;
        freeSeats: number;
        alreadyReserved: boolean;
        deleteReservation: (key: number) => void;
        switchReservation: () => void;
        deleteDate: () => void;
    }

    interface Place extends Partial<User> {
        hour: string;
        canReserveSeat: boolean;
        deleteReservation: () => void;
        switchReservation: () => void;
    }
}

export { User, DateElement, Place };
