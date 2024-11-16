import {
  Input,
  Checkbox,
  Button,
  Typography,
  Select,
  Option,
  Textarea,
} from "@material-tailwind/react";
import { useState } from "react";
import AuthService from "../services/auth-service"; 
import { useNavigate } from "react-router-dom";

export function SignUp() {
  const [profileType, setProfileType] = useState(""); 
  const [formData, setFormData] = useState({});
  const [loading, setLoading] = useState(false);
  const [error, setError] = useState(null);
  const navigate = useNavigate();

  const handleChange = (e) => {
    const { name, value } = e.target;
    setFormData((prevData) => ({
      ...prevData,
      [name]: value,
    }));
  };

  const handleSubmit = async (e) => {
    e.preventDefault();
    setLoading(true);
    setError(null);

    try {
      await AuthService.register({ profileType, ...formData });
      navigate("/sign(in"); 
    } catch (err) {
      setError("Une erreur s'est produite lors de l'inscription.");
    } finally {
      setLoading(false);
    }
  };

  const renderForm = () => {
    switch (profileType) {
      case "proprietaire":
        return (
          <div className="grid grid-cols-1 lg:grid-cols-2 gap-4">
            <Input label="Nom complet" size="lg" required name="fullName" onChange={handleChange} />
            <Input label="Pièce d’identité valide" size="lg" type="file" name="identityDocument" />
            <Input label="Adresse" size="lg" required name="address" onChange={handleChange} />
            <Input label="Email" size="lg" type="email" required name="email" onChange={handleChange} />
            <Input label="Numéro de téléphone" size="lg" type="tel" required name="phone" onChange={handleChange} />
            <Input label="Acte de propriétés ou titre foncier" size="lg" type="file" name="propertyAct" />
            <Input label="Plans cadastraux (si disponibles)" size="lg" type="file" name="cadastralPlans" />
            <Input label="Dernières factures de service" size="lg" type="file" name="serviceInvoices" />
            <Textarea label="Historique locatif (le cas échéant)" size="lg" name="rentalHistory" onChange={handleChange} />
          </div>
        );
      case "client":
        return (
          <div className="grid grid-cols-1 lg:grid-cols-2 gap-4">
            <Input label="Nom" size="lg" required name="lastName" onChange={handleChange} />
            <Input label="Prénom(s)" size="lg" required name="firstName" onChange={handleChange} />
            <Input label="Email" size="lg" type="email" required name="email" onChange={handleChange} />
            <Input label="Numéro de téléphone" size="lg" type="tel" required name="phone" onChange={handleChange} />
            <Input label="Mot de passe" size="lg" type="password" required name="password" onChange={handleChange} />
          </div>
        );
      case "agence":
        return (
          <div className="grid grid-cols-1 lg:grid-cols-2 gap-4">
            <Input label="Nom de l'agence" size="lg" required name="agencyName" onChange={handleChange} />
            <Input label="IFU" size="lg" type="number" required name="ifu" onChange={handleChange} />
            <Input label="Adresse complète" size="lg" required name="address" onChange={handleChange} />
            <Input label="Numéro de téléphone principal" size="lg" required name="phone" onChange={handleChange} />
            <Input label="Adresse email professionnelle" size="lg" type="email" required name="email" onChange={handleChange} />
            <Textarea label="Description des services" size="lg" name="servicesDescription" onChange={handleChange} />
            <Checkbox label="Vente" name="servicesSale" onChange={handleChange} />
            <Checkbox label="Location" name="servicesRental" onChange={handleChange} />
          </div>
        );
      default:
        return <Typography variant="h6">Veuillez sélectionner un profil pour commencer.</Typography>;
    }
  };

  return (
    <section className="m-8 flex">
      <div className="w-2/5 h-full hidden lg:block">
        <img
          src="/img/pattern.png"
          className="h-full w-full object-cover rounded-3xl"
        />
      </div>
      <div className="w-full lg:w-3/5 flex flex-col items-center justify-center">
        <div className="text-center">
          <Typography variant="h2" className="font-bold mb-4">Rejoignez-nous</Typography>
          <Typography variant="paragraph" color="blue-gray" className="text-lg font-normal">
            Entrez vos informations pour vous inscrire.
          </Typography>
        </div>
        <form className="mt-8 mb-2 mx-auto w-80 max-w-screen-lg lg:w-1/2" onSubmit={handleSubmit}>
          <div className="mb-6">
            <Select
              label="Sélectionnez un type de profil"
              value={profileType}
              onChange={(e) => setProfileType(e)}
            >
              <Option value="proprietaire">Propriétaire privé</Option>
              <Option value="client">Client</Option>
              <Option value="agence">Agence</Option>
            </Select>
          </div>
          <div className="flex flex-col gap-6">{renderForm()}</div>
          {error && (
            <Typography color="red" className="text-center mt-4">
              {error}
            </Typography>
          )}
          {profileType && (
            <Button className="mt-6" fullWidth type="submit" disabled={loading}>
              {loading ? "En cours..." : "S'inscrire"}
            </Button>
          )}
        </form>
      </div>
    </section>
  );
}

export default SignUp;
