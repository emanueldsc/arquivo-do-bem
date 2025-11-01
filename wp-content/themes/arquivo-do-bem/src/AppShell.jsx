import React from "react";
import { NavBar } from "./components/NavBar";
import { BrowserRouter, Routes, Route, RouterProvider } from "react-router-dom";

import "./styles/normalize.css";
import "./styles/style.css";
import { AuthProvider } from "./context/AuthContext";
import { router } from "./router";

export function AppShell() {
  return (
    <AuthProvider>
      <RouterProvider router={router} />
    </AuthProvider>
  );
}
