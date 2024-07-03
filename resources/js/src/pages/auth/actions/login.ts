import { ref } from "vue";
import { makeHttpReq } from "../../../helper/makeHttpReq";
import { showError, showSuccess } from "../../../helper/toast-notification";
import { showErrorResponse } from "../../../helper/util";

export type LoginUserType = {
    email: string;
    password: string;
};

export type LoginUserResponse = {
    user: { email: string, id: number };
    message: string;
    isLoggedIn: boolean,
    token: string
};

export const loginInput = ref<LoginUserType>({} as LoginUserType);

export function useLoginUser() {
    const loading = ref<boolean>(false);

    async function login() {
        try {
            loading.value = true;
            const data = await makeHttpReq<
                LoginUserType,
                LoginUserResponse
            >("login", "POST", loginInput.value);
            loading.value = false;
            loginInput.value = {} as LoginUserType;
            showSuccess(data.message);

            if(data.isLoggedIn) {
                console.log(data);
                localStorage.setItem("user", JSON.stringify(data));
                window.location.href = "/app/admin";
            }

        } catch (error) {
            loading.value = false;
            showErrorResponse(error);
        }
    }

    return { login, loading };
}
