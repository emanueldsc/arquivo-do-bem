import style from "./Logo.module.css";

export function Logo() {
  const envAssets = import.meta.env.VITE_ASSETS_URL;
  const wpAssets =
    typeof window !== "undefined" && window.__WP_DATA__?.assetsUrl;
  const defaultAssets = "http://localhost:5173/assets";

  const assetsBase = envAssets || wpAssets || defaultAssets;
  const logoSrc = `${defaultAssets}/logo.png`;

  console.log("logoSrc", logoSrc);

  return (
    <div className={style.container}>
      <img className={style.logo} src={logoSrc} alt="Logo" />
      <div>
        <h1 className={style.arquivo}>Arquivo</h1>
        <h1 className={style.do}>do</h1>
        <h1 className={style.bem}>Bem</h1>
      </div>
    </div>
  );
}
