interface User {
    id: number;
    name: string;
    admin: boolean;
    deleteUser: () => void;
}

interface DateElement {
    id: number;
    places: User[];
    date: string;
    old: boolean;
    user:User;
    freeSeats: () => number;
    alreadyReserved: () => boolean;
    deleteReservation: (key: number) => void;
    switchReservation: (key?: number) => void;
    deleteDate: () => void;
    hour: (key: number) => string;
    canReserveSeat: (place: User | null) => boolean;
}

export {User,DateElement}