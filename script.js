// =====================================================
// DELATOR - ELECTRIC BILL CALCULATOR
// Simple Single Page Application
// =====================================================

// Initialize page on load
document.addEventListener('DOMContentLoaded', function() {
    setDefaultMonth();
    loadBillsFromStorage();
});

// Set current month as default
function setDefaultMonth() {
    const monthInput = document.getElementById('month');
    if (monthInput) {
        const today = new Date();
        const year = today.getFullYear();
        const month = String(today.getMonth() + 1).padStart(2, '0');
        monthInput.value = `${year}-${month}`;
    }
}

// Calculator Form Handler
document.addEventListener('DOMContentLoaded', function() {
    const calculatorForm = document.getElementById('calculatorForm');
    if (calculatorForm) {
        calculatorForm.addEventListener('submit', function(e) {
            e.preventDefault();
            calculateBill();
        });
    }
});

// Calculate Bill Function
function calculateBill() {
    const kwh = parseFloat(document.getElementById('kwh').value);
    const costPerKwh = parseFloat(document.getElementById('costPerKwh').value);
    const month = document.getElementById('month').value;

    // Validation
    if (!kwh || !costPerKwh || !month) {
        alert('Please fill in all fields');
        return;
    }

    if (kwh <= 0 || costPerKwh <= 0) {
        alert('kWh and cost must be greater than 0');
        return;
    }

    // Calculate total bill
    const totalBill = kwh * costPerKwh;

    // Display results
    document.getElementById('resultKwh').textContent = kwh.toFixed(2) + ' kWh';
    document.getElementById('resultCostPerKwh').textContent = '₱' + costPerKwh.toFixed(2);
    document.getElementById('resultTotal').textContent = '₱' + totalBill.toFixed(2);
    document.getElementById('resultSection').style.display = 'block';

    // Store in localStorage for later use
    localStorage.setItem('lastCalculation', JSON.stringify({
        kwh: kwh,
        costPerKwh: costPerKwh,
        totalBill: totalBill,
        month: month,
        date: new Date().toLocaleString()
    }));

    // Scroll to results
    setTimeout(() => {
        document.getElementById('resultSection').scrollIntoView({ behavior: 'smooth' });
    }, 100);
}

// Save Bill Function
function saveBill() {
    const lastCalculation = JSON.parse(localStorage.getItem('lastCalculation'));
    
    if (!lastCalculation) {
        alert('No calculation to save');
        return;
    }

    // Get existing bills from localStorage
    let bills = JSON.parse(localStorage.getItem('bills')) || [];
    
    // Add new bill
    bills.push({
        id: Date.now(),
        ...lastCalculation
    });

    // Save back to localStorage
    localStorage.setItem('bills', JSON.stringify(bills));

    // Show success message
    alert('Bill saved successfully!');
    
    // Reload bills table
    loadBillsFromStorage();
    
    // Reset form
    document.getElementById('calculatorForm').reset();
    document.getElementById('resultSection').style.display = 'none';
    setDefaultMonth();
}

// Load Bills from Storage
function loadBillsFromStorage() {
    const bills = JSON.parse(localStorage.getItem('bills')) || [];
    const tableBody = document.getElementById('billsTableBody');
    const clearBtn = document.getElementById('clearBtn');
    
    if (!tableBody) return;
    
    if (bills.length === 0) {
        tableBody.innerHTML = '<tr><td colspan="5" class="text-center text-muted">No bills saved yet</td></tr>';
        clearBtn.style.display = 'none';
        return;
    }

    clearBtn.style.display = 'block';
    
    // Sort bills by date (newest first)
    bills.sort((a, b) => new Date(b.month) - new Date(a.month));
    
    tableBody.innerHTML = bills.map(bill => `
        <tr>
            <td>${formatMonth(bill.month)}</td>
            <td>${bill.kwh.toFixed(2)}</td>
            <td>₱${bill.costPerKwh.toFixed(2)}</td>
            <td><strong>₱${bill.totalBill.toFixed(2)}</strong></td>
            <td><button class="btn btn-sm btn-danger" onclick="deleteBill(${bill.id})">Delete</button></td>
        </tr>
    `).join('');
}

// Delete Bill Function
function deleteBill(billId) {
    if (!confirm('Are you sure you want to delete this bill?')) {
        return;
    }
    
    let bills = JSON.parse(localStorage.getItem('bills')) || [];
    bills = bills.filter(bill => bill.id !== billId);
    localStorage.setItem('bills', JSON.stringify(bills));
    
    loadBillsFromStorage();
}

// Clear All Bills Function
function clearAllBills() {
    if (!confirm('Are you sure you want to delete all bills? This cannot be undone.')) {
        return;
    }
    
    localStorage.removeItem('bills');
    loadBillsFromStorage();
    alert('All bills have been cleared!');
}

// Format Month Function
function formatMonth(monthString) {
    const date = new Date(monthString + '-01');
    return date.toLocaleDateString('en-US', { year: 'numeric', month: 'long' });
}

// Login Form Handler
document.addEventListener('DOMContentLoaded', function() {
    const loginForm = document.getElementById('loginForm');
    if (loginForm) {
        loginForm.addEventListener('submit', function(e) {
            e.preventDefault();
            handleLogin();
        });
    }
});

function handleLogin() {
    const email = document.getElementById('email').value;
    const password = document.getElementById('password').value;

    if (!email || !password) {
        alert('Please enter both email and password');
        return;
    }

    const user = {
        email: email,
        loginTime: new Date().toLocaleString(),
        rememberMe: document.getElementById('rememberMe').checked
    };

    localStorage.setItem('currentUser', JSON.stringify(user));
    localStorage.setItem('userProfile', JSON.stringify({
        firstName: email.split('@')[0],
        lastName: 'User',
        email: email,
        phone: '',
        address: ''
    }));
    
    alert('Login successful!');
    window.location.href = 'dashboard.html';
}

// Register Form Handler
document.addEventListener('DOMContentLoaded', function() {
    const registerForm = document.getElementById('registerForm');
    if (registerForm) {
        registerForm.addEventListener('submit', function(e) {
            e.preventDefault();
            handleRegister();
        });
    }
});

function handleRegister() {
    const fullName = document.getElementById('fullName').value;
    const email = document.getElementById('email').value;
    const phone = document.getElementById('phone').value;
    const address = document.getElementById('address').value;
    const password = document.getElementById('password').value;
    const confirmPassword = document.getElementById('confirmPassword').value;

    if (!fullName || !email || !phone || !address || !password || !confirmPassword) {
        alert('Please fill in all fields');
        return;
    }

    if (password !== confirmPassword) {
        alert('Passwords do not match');
        return;
    }

    if (password.length < 6) {
        alert('Password must be at least 6 characters long');
        return;
    }

    const user = {
        fullName: fullName,
        email: email,
        phone: phone,
        address: address,
        registrationDate: new Date().toLocaleString()
    };

    localStorage.setItem('user_' + email, JSON.stringify(user));
    
    alert('Registration successful! Please login.');
    window.location.href = 'login.html';
}

// Export functions for external use
window.calculateBill = calculateBill;
window.saveBill = saveBill;
window.deleteBill = deleteBill;
window.clearAllBills = clearAllBills;
