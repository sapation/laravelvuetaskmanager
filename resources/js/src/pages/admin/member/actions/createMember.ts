import { ref } from "vue";
import { makeHttpReq } from "../../../../helper/makeHttpReq";
import { showSuccess } from "../../../../helper/toast-notification";
import { showErrorResponse } from "../../../../helper/util";
import { memberStore } from "../store/memberStore";

export type MemberInputType = {
    email: string;
    name: string;
};

export type MemberResponse = {
    message: string;
};


export function useCreateOrUpdateMember() {
    const loading = ref<boolean>(false);

    async function createOrUpdateMember() {
        try {
            loading.value = true;
            const data = memberStore.edit
                ? await updateMember()
                : await createMember();
            loading.value = false;
            memberStore.memberInput = {} as MemberInputType;
            showSuccess(data.message);
        } catch (error) {
            loading.value = false;
            showErrorResponse(error);
        }
    }

    return { createOrUpdateMember, loading };
}

async function createMember() {
    const data = await makeHttpReq<MemberInputType, MemberResponse>(
        "members",
        "POST",
        memberStore.memberInput
    );

    return data;
}

async function updateMember() {
    const data = await makeHttpReq<MemberInputType, MemberResponse>(
        "members",
        "PUT",
        memberStore.memberInput
    );

    memberStore.edit = false;
    return data;
}