class GobieApi {

    constructor(baseUrl = null) {
        this.baseUrl = baseUrl ? baseUrl : process.env.GROOMING_CHIMPS_API_BASE_URI;
        this.errors = false;
        this.data = {};
    }

    hasErrors() {
        return this.errors;
    }

    getData() {
        return this.data;
    }

    getHeaders(anonymous = false) {
        let headers = {
            'user-agent': 'Gobie API JS Client',
            'content-type': 'application/ld+json'
        };

        const token = this.getToken();

        if (token && !anonymous) {
            headers.authorization = 'Bearer ' + token;
        }

        return headers;
    }

    setUser(details) {
        localStorage.setItem('user', JSON.stringify(details));
        this.setToken(details['token']);
    }

    getUser() {
        return localStorage.getItem('user');
    }

    setToken(token) {
        if (token) {
            localStorage.setItem('token', token);
        }
    }

    getToken() {
        return localStorage.getItem('token');
    }

    async auth(username, password) {
        const response = await fetch(this.baseUrl + '/users/auth', {
            cache: 'no-cache',
            headers: this.getHeaders(true),
            method: 'POST',
            redirect: 'follow',
            referrer: 'no-referrer',
            body: JSON.stringify({ username: username, password: password }),
        });

        this.data = await response.json();
        this.errors = !response.ok;

        return this.data;
    }
}

export default GobieApi;
