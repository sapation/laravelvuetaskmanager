import { APP } from "../App/App";

type HttpVerbType = "GET" | "POST" | "PUT" | "DELETE";

export function makeHttpReq<TInput, TResponse>(
    endpoint: string,
    verb: HttpVerbType,
    input: TInput
) {
    return new Promise<TResponse>(async(resolve, reject)=> {
        try {
            const res = await fetch(`${APP.apiBaseUrl}/${endpoint}`, {
                method: verb,
                headers: {
                    "content-type": "application/json"
                },
                body: JSON.stringify(input)
            });

            const data:TResponse = await res.json();

            if(!res.ok) {
                reject(data);
            }

            resolve(data)
        } catch (error) {
            reject(error);
        }
    })
}