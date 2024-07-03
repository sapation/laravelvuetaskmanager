import { ref } from "vue";
import { makeHttpReq } from "../../../helper/makeHttpReq";
import { showError, showSuccess } from "../../../helper/toast-notification";

export type LoginUserType = {
    email: string;
    password: string;
};

export type LoginUserResponse = {
    user: { email: string };
    message: string;
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
        } catch (error) {
            loading.value = false;

            for (const message of error as string[]) {
                showError(message);
            }
        }
    }

    return { login, loading };
}
