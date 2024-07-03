import { LoginUserResponse } from "../pages/auth/actions/login";

export function getUserData() : LoginUserResponse | undefined {
    try {
        const userData = localStorage.getItem("user");
        if(typeof userData !== 'object') {
            const connectedUser: LoginUserResponse = JSON.parse(userData);
            return connectedUser;
        }

    } catch (error) {
        console.log((error as Error).message);
    }
}