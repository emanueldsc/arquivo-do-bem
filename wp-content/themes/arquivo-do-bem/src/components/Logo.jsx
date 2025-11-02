import style from "./Logo.module.css";

export function Logo() {
  const assetsBase = window.__WP_DATA__?.assetsUrl

  console.log('assetsBase', assetsBase)
  console.log("logoSrc", logoSrc);
  
  const logoSrc = `assets/logo.png`;


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
