<?php

/**
 * @OA\Info(
 *     title="University Integrated Management Platform (UIMP) API",
 *     version="1.0.0",
 *     description="Core APIs for UIMP – shared entities, authentication, audit, subsystems.",
 *     @OA\Contact(
 *         email="admin@uimp.local"
 *     ),
 *     @OA\License(
 *         name="MIT",
 *         url="https://opensource.org/licenses/MIT"
 *     )
 * )
 *
 * @OA\Server(
 *     url=L5_SWAGGER_CONST_HOST,
 *     description="UIMP API Server"
 * )
 *
 * @OA\SecurityScheme(
 *     securityScheme="bearerAuth",
 *     type="http",
 *     scheme="bearer",
 *     bearerFormat="JWT"
 * )
 *
 * @OA\Tag(
 *     name="Authentication",
 *     description="Login, logout, token refresh, password reset"
 * )
 * @OA\Tag(
 *     name="Students",
 *     description="Student management (CRUD, search)"
 * )
 * @OA\Tag(
 *     name="Employees",
 *     description="Employee management"
 * )
 * @OA\Tag(
 *     name="Rooms",
 *     description="Room catalog (used by Room Subsystem)"
 * )
 * @OA\Tag(
 *     name="Subsystems",
 *     description="Subsystem registration and management"
 * )
 * @OA\Tag(
 *     name="Audit Logs",
 *     description="View immutable audit logs"
 * )
 * @OA\Tag(
 *     name="Notifications",
 *     description="Send and view notifications"
 * )
 */
