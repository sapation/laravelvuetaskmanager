import { ref } from "vue"
import { makeHttpReq } from "../../../helper/makeHttpReq"
import { showError, showSuccess } from "../../../helper/toast-notification"

export type RegisterUserType = {
    email: string,
    password: string
}

export type RegisterUserResponse = {
    user: { email: string },
    message: string
}

export const registerInput = ref<RegisterUserType>({} as RegisterUserType);

export function useRegisterUser() {
    const loading = ref<boolean>(false);

    async function register() {
        try {
            loading.value = true;
            const data = await makeHttpReq<
                RegisterUserType,
                RegisterUserResponse
            >("register", "POST", registerInput.value);
            loading.value = false;
            registerInput.value = {} as RegisterUserType;
            showSuccess(data.message);
        } catch (error) {
            loading.value = false;

            for(const message of error as string[]) {
                showError(message)
            }
        }
    }

    return {register, loading};
}