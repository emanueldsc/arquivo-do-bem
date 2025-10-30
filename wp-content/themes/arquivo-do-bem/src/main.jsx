import React from 'react'
import { createRoot } from 'react-dom/client'
import axios from 'axios'

console.log('MAIN JSX CARREGOU');

function App() {
  const [data, setData] = React.useState(null)

  React.useEffect(() => {
    axios.get('/wp-json/adb/v1/ping').then(res => setData(res.data)).catch(console.error)
  }, [])

  return (
    <div style={{ padding: 4 }}>
      <p>Emanuel Douglas</p>
    </div>
  )
}

createRoot(document.getElementById('root')).render(<App />)
