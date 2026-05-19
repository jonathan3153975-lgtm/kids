#!/usr/bin/env python3

import http.server
import socketserver
import os
import subprocess
import urllib.parse
import sys

class PHPProxyHandler(http.server.BaseHTTPRequestHandler):
    def do_GET(self):
        self.handle_request('GET')

    def do_POST(self):
        self.handle_request('POST')

    def handle_request(self, method):
        # Parse the URL
        parsed_url = urllib.parse.urlparse(self.path)
        path = parsed_url.path
        query = parsed_url.query

        # Set environment variables for PHP
        env = os.environ.copy()
        env['REQUEST_METHOD'] = method
        env['REQUEST_URI'] = self.path
        env['QUERY_STRING'] = query
        env['SCRIPT_NAME'] = '/index.php'
        env['PHP_SELF'] = '/index.php'
        env['SERVER_NAME'] = 'localhost'
        env['SERVER_PORT'] = '8080'
        env['REMOTE_ADDR'] = self.client_address[0]
        env['DOCUMENT_ROOT'] = os.path.join(os.getcwd(), 'public')

        # Handle POST data
        if method == 'POST':
            content_length = int(self.headers.get('Content-Length', 0))
            post_data = self.rfile.read(content_length).decode('utf-8')
            env['CONTENT_LENGTH'] = str(len(post_data))
            env['CONTENT_TYPE'] = self.headers.get('Content-Type', '')

            # Write POST data to stdin
            stdin_data = post_data
        else:
            stdin_data = None

        # Run PHP
        try:
            result = subprocess.run(
                ['php', 'public/index.php'],
                input=stdin_data,
                capture_output=True,
                text=True,
                env=env,
                cwd=os.getcwd(),
                timeout=30
            )

            # Send response
            self.send_response(200)
            self.send_header('Content-type', 'text/html; charset=UTF-8')
            self.send_header('Cache-Control', 'no-store, no-cache, must-revalidate')
            self.end_headers()
            self.wfile.write(result.stdout.encode('utf-8'))

        except subprocess.TimeoutExpired:
            self.send_error(504, "Gateway Timeout")
        except Exception as e:
            self.send_error(500, f"Internal Server Error: {str(e)}")

    def log_message(self, format, *args):
        # Suppress default logging
        pass

if __name__ == '__main__':
    port = 8080
    with socketserver.TCPServer(('', port), PHPProxyHandler) as httpd:
        print(f'PHP proxy server running at http://localhost:{port}')
        print('Press Ctrl+C to stop')
        try:
            httpd.serve_forever()
        except KeyboardInterrupt:
            print('\nServer stopped')