import { Outlet } from "react-router-dom";
import { NavBar } from "./NavBar";

export function Layout() {
  return (
    <>
      <NavBar />
      <main style={{ padding: 16 }}>
        <Outlet />
      </main>
    </>
  );
}
