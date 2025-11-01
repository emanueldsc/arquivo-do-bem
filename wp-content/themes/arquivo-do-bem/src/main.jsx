import React from 'react'
import { createRoot } from 'react-dom/client'
import axios from 'axios'
import { AppShell } from './AppShell'

function App() {
  const [data, setData] = React.useState(null)

  React.useEffect(() => {
    axios.get('/wp-json/adb/v1/ping').then(res => setData(res.data)).catch(console.error)
  }, [])

  return (
    <AppShell />
  )
}

createRoot(document.getElementById('root')).render(<App />)
