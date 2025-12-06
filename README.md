# ⚡ Delator - Electric Bill Calculator

A modern, responsive web application for calculating and managing electricity bills with an elegant glass-morphism design.

## 🎯 Features

- **Bill Calculator**: Quick and easy bill calculation based on kWh consumption
- **User Authentication**: Register and login system
- **Dashboard**: View personalized dashboard with consumption statistics
- **Bill History**: Track all bills with advanced filtering options
- **Profile Management**: Edit user information and change password
- **Responsive Design**: Works seamlessly on desktop, tablet, and mobile devices
- **Modern UI**: Glass-morphism design with smooth animations
- **Local Storage**: Client-side data persistence without backend requirements

## 📁 Project Structure

```
delator-electric-bill-calculator/
├── index.html          # Home page
├── calculator.html     # Bill calculator page
├── dashboard.html      # User dashboard
├── results.html        # Bill history and results
├── login.html          # Login page
├── register.html       # Registration page
├── profile.html        # User profile page
├── style.css           # Global styles (glass-morphism design)
├── script.js           # JavaScript functionality
└── README.md           # This file
```

## 🚀 Getting Started

### Prerequisites
- A modern web browser (Chrome, Firefox, Safari, Edge)
- No server or database required (runs entirely on the client)

### Installation

1. **Clone or Download** the project files
2. **Open in Browser**: Simply open `index.html` in your web browser
3. **No Installation Needed**: The application runs entirely in the browser

### Usage

#### Home Page (`index.html`)
- Overview of the application
- Quick navigation to calculator
- Feature highlights

#### Calculator (`calculator.html`)
1. Enter your kWh consumption
2. Set the cost per kWh (default: ₱12.50)
3. Select the billing month
4. Add a reference number
5. Click "Calculate Bill"
6. Save the bill to history

#### Dashboard (`dashboard.html`)
- View total consumption statistics
- See total amount paid
- View monthly average consumption
- Quick access to recent bills

#### Bill Results (`results.html`)
- View complete bill history
- Filter by month, year, and payment status
- View individual bill details
- Track payment status

#### Login/Register
- Create a new account
- Secure login with email and password
- "Remember me" option for faster login

#### Profile (`profile.html`)
- Edit personal information
- Change password
- View account statistics

## 🎨 Design Features

### Color Scheme
- **Primary Color**: Dark Red (#6e1411)
- **Accent Color**: Coral Red (#ff6b6b)
- **Background**: Dark Gradient (Black to Dark Gray)
- **Text**: White and Light Gray

### Typography
- **Header Font**: Pirata One (decorative)
- **Body Font**: Montserrat (modern, clean)

### UI Elements
- Glass-morphism cards with blur effects
- Smooth animations and transitions
- Responsive grid layouts
- Bootstrap 5.3 for components
- Bootstrap Icons for visual elements

## 💾 Data Storage

The application uses **localStorage** to persist data:

- **bills**: Array of saved bill records
- **currentUser**: Currently logged-in user session
- **userProfile**: User profile information
- **lastCalculation**: Most recent calculation

### Bill Object Structure
```json
{
  "id": 1701234567890,
  "kwh": 350,
  "costPerKwh": 12.50,
  "totalBill": 4375.00,
  "month": "2025-12",
  "reference": "REF001",
  "date": "12/6/2025, 10:35:28 AM",
  "status": "pending"
}
```

## 🔐 Security Notes

- **Client-Side Only**: All data is stored locally in the browser
- **No Server Communication**: No data sent to external servers
- **LocalStorage Limitations**: Data is cleared if browser history/cache is cleared
- **For Production**: Implement proper backend authentication and database for real-world use

## 📱 Responsive Breakpoints

- **Desktop**: 1024px and above
- **Tablet**: 768px - 1023px
- **Mobile**: Below 768px
- **Small Mobile**: Below 576px

## 🎯 JavaScript Functions

### Calculator Functions
- `calculateBill()`: Calculates electricity bill based on input
- `saveBill()`: Saves calculated bill to localStorage

### Authentication Functions
- `handleLogin()`: Processes user login
- `handleRegister()`: Creates new user account
- `logout()`: Clears user session

### Dashboard Functions
- `loadDashboardData()`: Loads and displays user statistics
- `applyFilters()`: Filters bills by month, year, status
- `displayFilteredBills()`: Renders filtered bills in table

### Utility Functions
- `setDefaultMonth()`: Sets current month in date inputs
- `formatMonth()`: Formats month string to readable format
- `checkAuth()`: Verifies user authentication

## 🌐 Browser Support

- ✅ Chrome/Chromium 90+
- ✅ Firefox 88+
- ✅ Safari 14+
- ✅ Edge 90+

## 📦 Dependencies

- **Bootstrap 5.3**: CDN-linked (no installation needed)
- **Bootstrap Icons**: CDN-linked
- **Google Fonts**: Pirata One & Montserrat (CDN-linked)
- **Vanilla JavaScript**: No external libraries required

## 🚀 Future Enhancements

- [ ] Backend integration for data persistence
- [ ] User authentication with secure sessions
- [ ] Database for bill history
- [ ] PDF bill generation
- [ ] Email notifications
- [ ] Bill payment integration
- [ ] Multiple user support
- [ ] Bill analytics and charts
- [ ] Mobile app version
- [ ] Dark/Light theme toggle

## 🤝 Contributing

Feel free to fork, modify, and improve this project!

## 📄 License

This project is free to use and modify for personal and commercial purposes.

## 👨‍💻 Author

Created as a modern electric bill calculator application inspired by the Ngalis Electric Bill Calculator design patterns.

## 📞 Support

For issues or questions, please check the code comments or review the script.js file for detailed function documentation.

---

**Delator** - Making Electric Bill Calculation Simple and Beautiful ⚡
