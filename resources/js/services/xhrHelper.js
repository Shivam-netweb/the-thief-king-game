import axios from "axios";

const routePrefix = 'api/v1';

export async function loginUser(credentials){
    let route = '/login';
    return await axios.post(routePrefix + route, credentials)
}

export async function RegisterNewUser(form){
    let route = '/register';
    return await axios.post(routePrefix + route, form)
}

export async function generateAuthToken(userID){
    let route = `/auth/${userID}/generate-token`;
    return await axios.post(routePrefix + route);
}

export async function startNewGame(random = false){
    let route = `/new-game/?random=${random}`;
    return await axios.post(routePrefix + route);
}
