import { defineStore } from "pinia";
import { MemberType } from "../actions/createMember";

const useMemberStore = defineStore("member", {
    state: () => ({
        memberInput: {} as MemberType,
        edit: false
    }),
});

export const memberStore = useMemberStore();