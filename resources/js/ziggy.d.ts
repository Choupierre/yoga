/* This file is generated by Ziggy. */
declare module 'ziggy-js' {
  interface RouteList {
    "debugbar.openhandler": [],
    "debugbar.clockwork": [
        {
            "name": "id",
            "required": true
        }
    ],
    "debugbar.assets.css": [],
    "debugbar.assets.js": [],
    "debugbar.cache.delete": [
        {
            "name": "key",
            "required": true
        },
        {
            "name": "tags",
            "required": false
        }
    ],
    "debugbar.queries.explain": [],
    "sanctum.csrf-cookie": [],
    "ignition.healthCheck": [],
    "ignition.executeSolution": [],
    "ignition.updateConfig": [],
    "dates.index": [],
    "dates.store": [],
    "dates.show": [
        {
            "name": "date",
            "required": true
        }
    ],
    "dates.update": [
        {
            "name": "date",
            "required": true,
            "binding": "id"
        }
    ],
    "dates.destroy": [
        {
            "name": "date",
            "required": true,
            "binding": "id"
        }
    ],
    "users.index": [],
    "users.store": [],
    "users.show": [
        {
            "name": "user",
            "required": true,
            "binding": "id"
        }
    ],
    "users.update": [
        {
            "name": "user",
            "required": true,
            "binding": "id"
        }
    ],
    "users.destroy": [
        {
            "name": "user",
            "required": true,
            "binding": "id"
        }
    ],
    "companies.index": [],
    "companies.store": [],
    "companies.show": [
        {
            "name": "company",
            "required": true
        }
    ],
    "companies.update": [
        {
            "name": "company",
            "required": true,
            "binding": "id"
        }
    ],
    "companies.destroy": [
        {
            "name": "company",
            "required": true
        }
    ],
    "home": [],
    "register": [],
    "login": [],
    "password.request": [],
    "password.email": [],
    "password.reset": [
        {
            "name": "token",
            "required": true
        }
    ],
    "password.update": [],
    "logout": []
}
}
export {};
