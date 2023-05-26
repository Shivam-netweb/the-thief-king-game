import React from "react";
import { useNavigate } from "react-router-dom";
export default function Register() {
    const navigate = useNavigate();
    const handleSubmit = async (event) => {
        event.preventDefault();
        try {
            const response = await RegisterNewUser(new FormData(event.target));
            notify(response.data.message, response.data.status);
            navigate("/login");
        } catch (err) {
            let error = err.response.data;
            if (error.errors != undefined) {
                Object.keys(error.errors).map(
                    (input) =>
                        (event.target[input].nextElementSibling.innerText =
                            error.errors[input].join(", "))
                );
            } else {
                notify(error.error, "error");
            }
        }
    };
    return (
        <form>
            <input type="text" name="first_name" placeholder="First Name" />
            <input type="text" name="last_name" placeholder="Last Name" />
            <input type="email" name="email" placeholder="email" />
            <input type="password" name="password" placeholder="Password" />
            <input
                type="password"
                name="confirm_password"
                placeholder="Confirm Password"
            />
            <button type="submit">Submit</button>
        </form>
    );
}
