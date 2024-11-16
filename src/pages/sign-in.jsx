import {
  Input,
  Checkbox,
  Button,
  Typography,
  Alert,
} from "@material-tailwind/react";
import { Link, useNavigate } from "react-router-dom";
import { useState } from "react";
import AuthService from "../services/auth-service";

export function SignIn() {
  const navigate = useNavigate();

  const [email, setEmail] = useState("");
  const [password, setPassword] = useState("");
  const [error, setError] = useState("");
  const [loading, setLoading] = useState(false);

  const handleSubmit = async (e) => {
    e.preventDefault();
    setError(""); 
    setLoading(true); 

    if (!email || !password) {
      setError("Veuillez remplir tous les champs.");
      setLoading(false);
      return;
    }

    try {
      const response = await AuthService.login({ email, password });
      if (response?.status === 200) {
        // Sauvegarder le token ou les données utilisateur si nécessaire
        localStorage.setItem("user", JSON.stringify(response.data));
        navigate("/landing"); // Rediriger vers la page principale
      } else {
        throw new Error(response?.data?.message || "Erreur inconnue.");
      }
    } catch (err) {
      setError(err.message || "Échec de la connexion. Veuillez réessayer.");
    } finally {
      setLoading(false);
    }
  };

  return (
    <section className="m-8 flex gap-4">
      <div className="w-full lg:w-3/5 mt-24">
        <div className="text-center">
          <Typography variant="h2" className="font-bold mb-4">
            Connexion
          </Typography>
          <Typography
            variant="paragraph"
            color="blue-gray"
            className="text-lg font-normal"
          >
            Entrez votre adresse e-mail et votre mot de passe pour vous connecter.
          </Typography>
        </div>
        <form
          className="mt-8 mb-2 mx-auto w-80 max-w-screen-lg lg:w-1/2"
          onSubmit={handleSubmit}
        >
          {error && <Alert color="red" className="mb-4">{error}</Alert>}

          <div className="mb-1 flex flex-col gap-6">
            <Typography
              variant="small"
              color="blue-gray"
              className="-mb-3 font-medium"
            >
              Votre e-mail
            </Typography>
            <Input
              size="lg"
              placeholder="nom@mail.com"
              value={email}
              onChange={(e) => setEmail(e.target.value)}
              className="!border-t-blue-gray-200 focus:!border-t-gray-900"
              labelProps={{
                className: "before:content-none after:content-none",
              }}
            />
            <Typography
              variant="small"
              color="blue-gray"
              className="-mb-3 font-medium"
            >
              Mot de passe
            </Typography>
            <Input
              type="password"
              size="lg"
              placeholder="********"
              value={password}
              onChange={(e) => setPassword(e.target.value)}
              className="!border-t-blue-gray-200 focus:!border-t-gray-900"
              labelProps={{
                className: "before:content-none after:content-none",
              }}
            />
          </div>
          <Checkbox
            label={
              <Typography
                variant="small"
                color="gray"
                className="flex items-center justify-start font-medium"
              >
                J'accepte les&nbsp;
                <a
                  href="#"
                  className="font-normal text-black transition-colors hover:text-gray-900 underline"
                >
                  Termes et Conditions
                </a>
              </Typography>
            }
            containerProps={{ className: "-ml-2.5" }}
          />
          <Button
            className="mt-6"
            fullWidth
            type="submit"
            disabled={loading}
          >
            {loading ? "Connexion..." : "Se connecter"}
          </Button>

          <div className="flex items-center justify-between gap-2 mt-6">
            <Checkbox
              label={
                <Typography
                  variant="small"
                  color="gray"
                  className="flex items-center justify-start font-medium"
                >
                  Souscrire à notre newsletter
                </Typography>
              }
              containerProps={{ className: "-ml-2.5" }}
            />
            <Typography variant="small" className="font-medium text-gray-900">
              <a href="#">Mot de passe oublié</a>
            </Typography>
          </div>
          <Typography
            variant="paragraph"
            className="text-center text-blue-gray-500 font-medium mt-4"
          >
            Pas encore inscrit ?
            <Link to="/sign-up" className="text-gray-900 ml-1">
              Créer un compte
            </Link>
          </Typography>
        </form>
      </div>
      <div className="w-2/5 h-full hidden lg:block">
        <img
          src="/img/pattern.png"
          className="h-full w-full object-cover rounded-3xl"
        />
      </div>
    </section>
  );
}

export default SignIn;
