import { Home, Profile } from "@/pages";

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
];

export default routes;
