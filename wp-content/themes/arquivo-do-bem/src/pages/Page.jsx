export function Page({ title, subtitle, children }) {
  return (
    <section style={{ padding: 16 }}>
      {title && <h1 style={{ margin: 0 }}>{title}</h1>}
      {subtitle && (
        <p style={{ marginTop: 6, opacity: 0.7 }}>{subtitle}</p>
      )}

      <div style={{ marginTop: 16 }}>
        {children}
      </div>
    </section>
  );
}
