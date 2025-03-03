declare const __brand: unique symbol
type Brand<B> = { [__brand]: B }
type Branded<T, B> = T & Brand<B>

type UserId = Branded<number, 'userId'>

type Company = {
    id: number;
    name: string;
    groups: {
        name: string;
        ids: UserId[];
    }[];
}

type UserElement = {
    id: UserId;
    name: string;
    email: string;
    admin: boolean;
    active: boolean;
    activated: boolean;
    company: { name: string };
    config: { group: boolean; slots: number; display_teacher_name: boolean, duration: number,canSeeOther?:boolean };
}

type DateElement = {
    id: number;
    places: (UserId | null)[];
    waiting: UserId[];
    date: string;
    date_for_humans: string;
    old: boolean;
    user: UserElement;
    has_free_seats: number;
    already_reserved: boolean;
    already_waiting: boolean;
}
