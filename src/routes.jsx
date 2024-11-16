import { Home, Profile, SignIn } from "@/pages";

export const routes = [
  {
    name: "landing",
    path: "/landing",
    element: <Home />,
  },
  {
    name: "profile",
    path: "/profile",
    element: <Profile />,
  },
  {
    name: "connexion",
    path: "/sign-in",
    element: <SignIn />,
  },
];

export default routes;
