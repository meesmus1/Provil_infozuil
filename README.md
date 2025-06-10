# 🖥️ Infozuil

> 📚 GIP-project 2024–2025 – Provil | ICW6  
> 👨‍💻 Gerealiseerd door: Finn Van den Eynden & Mees van der Heijden  
> 🔗 Doel: Snelle en duidelijke communicatie van afwezigheden via digitale schermen

---

## 📖 Over het project

Op school worden dagelijks leerkrachten ziek gemeld, verplaatst of afwezig verklaard. Tot nu toe gebeurde de communicatie hierover vaak mondeling of via papieren briefjes, wat niet altijd efficiënt of duidelijk was. Daarom ontwikkelden we de **Infozuil**: een systeem waarbij schermen in de gangen automatisch tonen welke leerkrachten afwezig zijn, gebaseerd op input van het secretariaat.

De content wordt grafisch weergegeven via **Canva** en is op elk moment eenvoudig aanpasbaar zonder technische kennis. Door deze digitale oplossing zorgen we voor minder verwarring, betere communicatie en een vlottere werking op school.

---

## 🚀 Functionaliteiten

- 📺 Automatische weergave van afwezigheden op TV-schermen
- 🔗 Embedden van **Canva-presentaties** via een beheersbare link
- 🔁 Automatische verversing van de content
- 🔐 Inlogsysteem voor beheerder
- 🖱️ Gebruik van een **schakelaar klikker** om TV op afstand aan/uit te zetten
- 🌐 Volledig browsergebaseerd: geen installatie vereist

---

## 🧩 Technologieën

| Technologie | Gebruik |
|------------|---------|
| `HTML/CSS` | Structuur en vormgeving van de interface op de schermen |
| `JavaScript` | Dynamische elementen zoals auto-refresh |
| `PHP` | Backendlogica voor inloggen en ophalen van links |
| `MySQL` | Opslag van Canva-links, logingegevens en TV-instellingen |
| `Canva` | Voor visuele creatie van informatiepresentaties |
| `Hardware` | TV-scherm en klikschakelaar voor aan/uit-functionaliteit |

---

## 🛠️ Installatiehandleiding

1. **Vereisten**
   - XAMPP (of LAMP-stack)
   - TV met HDMI en toegang tot de lokale server via browser
   - Schakelaar klikker (optioneel) aangesloten op TV

2. **Clone de repository**

```bash
git clone https://github.com/meesmus1/provil_infozuil.git
